<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\ProductAttribute;
use App\Entity\ProductValue;
use App\Repository\ProductAttributeRepository;
use App\Repository\ProductValueRepository;
use RuntimeException;

class ImportProductAttributesService
{
    private const ATTRIBUTE_TYPES_PATTERN = 'attribute_types';
    private const ATTRIBUTE_VALUES_PATTERN = 'attribute_values';


    public function __construct(
        private readonly ProductAttributeRepository $productAttributeRepository,
        private readonly ProductValueRepository $productValueRepository,
    )
    {
    }

    public function import(string $dir): void
    {
        $this->validateSubscribers();

        $files = scandir($dir);

        foreach ($files as $fileName) {
            $this->processFile($dir, $fileName);
        }
    }

    private function validateSubscribers(): void
    {
        $importSubscribers = $this->getImportTypeSubscribers();

        foreach ($importSubscribers as $importSubscriber) {
            if (!method_exists($this, $importSubscriber)) {
                throw new RuntimeException('Subscriber ' . $importSubscriber . ' not found.');
            }
        }
    }

    private function getImportTypeSubscribers(): array
    {
        return [
            self::ATTRIBUTE_TYPES_PATTERN => 'processAttributeTypeRow',
            self::ATTRIBUTE_VALUES_PATTERN => 'processAttributeValueRow',
        ];
    }

    private function processFile(string $dir, string $fileName): void
    {
        $importSubscribers = $this->getImportTypeSubscribers();

        foreach ($importSubscribers as $importPattern => $importFunction) {
            $filePattern = '/^(' . $importPattern . ')(.*)\.csv$/';

            $matches = preg_match($filePattern, $fileName);

            if ($matches) {
                $this->importFile($dir, $fileName, $importFunction);
            }
        }
    }

    private function importFile(string $dir, string $fileName, string $importFunction): void
    {
        $filePath = $dir . '/' . $fileName;
        $handle = fopen($filePath, 'rb');

        // skip headers
        fgetcsv($handle);

        $chunksize = 25;

        $importedCount = 0;

        while (!feof($handle)) {
            for ($i = 0; $i < $chunksize; $i++) {
                $isImported = $this->$importFunction($handle);
                $importedCount += $isImported ? 1 : 0;
            }
        }

        fclose($handle);

        var_dump(sprintf('Imported %s rows from %s', $importedCount, $fileName));
    }

    private function processAttributeTypeRow($handle): bool
    {
        $attributeTypeData = fgetcsv($handle);

        if (false === $attributeTypeData) {
            return false;
        }

        $importId = (int)$attributeTypeData[0];
        $parentImportId = (int)$attributeTypeData[1];

        $importHash = sprintf('at_%s_%s', $importId, $parentImportId);

        $productAttribute = $this->productAttributeRepository->findOneByImportHash($importHash);

        if (null === $productAttribute) {
            $productAttribute = new ProductAttribute();
            $productAttribute->import_id = $importId;
            $productAttribute->import_hash = $importHash;
        }

        if (!empty($parentImportId)) {
            $productAttribute->parent_import_id = $parentImportId;

            $parentProductAttribute = $this->productAttributeRepository->findOneByImportId($parentImportId);

            if (null === $parentProductAttribute) {
                throw new RuntimeException(sprintf('Parent attribute type not found for id: %s', $parentImportId));
            }

            $productAttribute->parent_id = $parentProductAttribute->getId();
        }

        $productAttribute->offer_type = $attributeTypeData[2];
        $productAttribute->name = $attributeTypeData[3];

        $this->productAttributeRepository->save($productAttribute);

        return true;
    }

    private function processAttributeValueRow($handle): bool
    {
        $attributeValueData = fgetcsv($handle);

        if (false === $attributeValueData) {
            return false;
        }

        $importId = (int)$attributeValueData[0];
        $attributeId = (int)$attributeValueData[1];
        $parentImportId = !empty($attributeValueData[3]) ? (int)$attributeValueData[3] : null;

        $productAttribute = $this->productAttributeRepository->findOneById($attributeId);

        if (!$productAttribute) {
            throw new RuntimeException('Attribute type not found');
        }

        $importHash = sprintf('av_%s_%s', $importId, $attributeId);

        $productValue = $this->productValueRepository->findByImportHash($importHash);

        if (null === $productValue) {
            $productValue = new ProductValue();
            $productValue->import_id = $importId;
            $productValue->import_hash = $importHash;
        }

        if (null !== $parentImportId) {
            $parentProductAttribute = $this->productAttributeRepository->findOneById($productAttribute->parent_id);

            if (!$parentProductAttribute) {
                throw new RuntimeException('Parent attribute type not found');
            }

            $productValue->parent_import_id = $parentImportId;

            $parentAttributeValue = AttributeValue::where([
                'import_id' => $parentImportId,
                'attribute_type_id' => $parentProductAttribute->id
            ])->first();

            if (null === $parentAttributeValue) {
                throw new RuntimeException(sprintf('Parent attribute value not found for id: %s', $parentImportId));
            }

            $productValue->parent_id = $parentAttributeValue->id;
        }

        $productValue->attribute_type_id = $productAttribute->id;
        $productValue->value = $attributeValueData[2];

        $this->productValueRepository->save($productValue);

        return true;
    }
}