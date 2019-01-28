from parsers.base_parser import BaseParser
from items.book_item import BookItem
# from parser_src.parsers.base_parser import BaseParser
# from parser_src.items.book_item import BookItem


class BookclubParser(BaseParser):

    def __init__(self):
        pass

    def parse_book_page(self, response):
        book_item = BookItem()

        book_item['name'] = self.parse_name(response)
        book_item['original_name'] = self.parse_original_name(response)
        book_item['author'] = self.parse_author(response)
        book_item['price'] = self.parse_price(response)
        book_item['currency'] = self.parse_currency(response)
        book_item['language'] = self.parse_language(response)
        book_item['original_language'] = self.parse_original_language(response)
        book_item['paperback'] = self.parse_paperback(response)
        book_item['product_dimensions'] = self.parse_product_dimensions(response)
        book_item['publisher'] = self.parse_publisher(response)
        book_item['publishing_year'] = self.parse_publishing_year(response)
        book_item['isbn'] = self.parse_isbn(response)
        book_item['link'] = response.url
        book_item['image_urls'] = self.parse_image_urls(response)
        book_item['weight'] = self.parse_weight(response)

        return book_item

    def parse_name(self, response):
        name = response.xpath("//div[contains(text(),'Название товара')]/following::div[1]/text()").extract_first()
        return name

    def parse_original_name(self, response):
        original_name = response.xpath("//div[contains(text(),'Оригинальное название')]/following::div[1]/text()").extract_first()
        return original_name

    def parse_author(self, response):
        author = response.xpath("//div[contains(text(),'Aвтор')]/following::div[1]/text()").extract_first()
        return author

    def parse_price(self, response):
        price = response.xpath("//div[@class='prd-enov-pr-numb']/text()").extract_first()
        return price

    def parse_currency(self, response):
        currency = response.xpath("//span[@class='prd-your-price-valute']/text()").extract_first()
        return currency

    def parse_language(self, response):
        language = response.xpath("//div[contains(text(),'Язык')]/following::div[1]/text()").extract_first()
        return language

    def parse_original_language(self, response):
        original_language = response.xpath("//div[contains(text(),'Язык оригинала')]/following::div[1]/text()").extract_first()
        return original_language

    def parse_paperback(self, response):
        paperback = response.xpath("//div[contains(text(),'Страниц')]/following::div[1]/text()").extract_first()
        return paperback

    def parse_product_dimensions(self, response):
        product_dimensions = response.xpath("//div[contains(text(),'Формат')]/following::div[1]/text()").extract_first()
        return product_dimensions

    def parse_publisher(self, response):
        publisher = response.xpath("//div[contains(text(),'Издательство')]/following::div[1]/a/text()").extract_first()
        return publisher

    def parse_publishing_year(self, response):
        publishing_year = response.xpath("//div[contains(text(),'Год издания')]/following::div[1]/text()").extract_first()
        return publishing_year

    def parse_isbn(self, response):
        isbn = response.xpath("//div[contains(text(),'ISBN')]/following::div[1]/text()").extract_first()
        return isbn

    def parse_image_urls(self, response):
        image_url = response.xpath("//div[@class='prd-image']/a/@href").extract_first()
        image_url = response.urljoin(image_url)
        image_urls = [image_url]
        return image_urls

    def parse_weight(self, response):
        weight = response.xpath("//div[contains(text(),'Вес')]/following::div[1]/text()").extract_first()
        return weight