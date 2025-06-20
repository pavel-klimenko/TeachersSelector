<?php
//
//namespace App\Application\DTO;
//
//use
//use App\Application\DTO\ProductDTO;A
//
//class NewsAssembler
//{
//    public function toDTO(Product $product): ProductDTO
//    {
//        $dto = new ProductDTO();
//        $dto->id = $product->getId()->getValue();
//        $dto->name = $product->getName()->getValue();
//        $dto->price = $product->getPrice()->getValue();
//        return $dto;
//    }
//
//    public function toEntity(ProductDTO $dto): Product
//    {
//        return new Product(
//            new ProductId($dto->id),
//            new ProductName($dto->name),
//            new Price($dto->price)
//        );
//    }
//}