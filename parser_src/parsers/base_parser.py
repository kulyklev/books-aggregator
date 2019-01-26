from abc import ABC, abstractmethod


class BaseParser(ABC):

    @abstractmethod
    def parse_book_page(self, response):
        pass

    @abstractmethod
    def parse_name(self, response):
        pass

    @abstractmethod
    def parse_original_name(self, response):
        pass

    @abstractmethod
    def parse_author(self, response):
        pass

    @abstractmethod
    def parse_price(self, response):
        pass

    @abstractmethod
    def parse_currency(self, response):
        pass

    @abstractmethod
    def parse_language(self, response):
        pass

    @abstractmethod
    def parse_original_language(self, response):
        pass

    @abstractmethod
    def parse_paperback(self, response):
        pass

    @abstractmethod
    def parse_product_dimensions(self, response):
        pass

    @abstractmethod
    def parse_publisher(self, response):
        pass

    @abstractmethod
    def parse_publishing_year(self, response):
        pass

    @abstractmethod
    def parse_isbn(self, response):
        pass

    @abstractmethod
    def parse_image_urls(self, response):
        pass

    @abstractmethod
    def parse_weight(self, response):
        pass