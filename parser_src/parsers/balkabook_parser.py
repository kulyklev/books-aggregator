from parsers.base_parser import BaseParser
from items.book_item import BookItem
# from parser_src.parsers.base_parser import BaseParser
# from parser_src.items.book_item import BookItem


class BalkaBookParser(BaseParser):

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
        name = response.xpath("//h1[@itemprop='name']/text()").extract_first()
        return name

    def parse_original_name(self, response):
        original_name = response.xpath("//dl[contains(text(),'Оригинальное название')]/following::dd[1]/a/text()").extract_first()
        return original_name

    def parse_author(self, response):
        # TODO When book has two or more authors, DOM changes like on this page https://balka-book.com/python-70/postroenie_sistem_mashinnogo_obucheniya_na_yazyike_python-33080
        author = response.xpath("//dl[contains(text(),'Автор')]/following::dd[1]/a/text()").extract_first()
        return author

    def parse_price(self, response):
        price = response.xpath("//meta[@itemprop='price']/@content").extract_first()
        return price

    def parse_currency(self, response):
        currency = response.xpath("//meta[@itemprop='priceCurrency']/@content").extract_first()
        return currency

    def parse_language(self, response):
        language = response.xpath("//dl[contains(text(),'Язык')]/following::dd[1]/text()").extract_first()
        return language

    def parse_original_language(self, response):
        # TODO I didn`t find this field yet
        return None

    def parse_paperback(self, response):
        paperback = response.xpath("//dl[contains(text(),'Страниц')]/following::dd[1]/text()").extract_first()
        return paperback

    def parse_product_dimensions(self, response):
        product_dimensions = response.xpath("//dl[contains(text(),'Формат')]/following::dd[1]/text()").extract_first()
        return product_dimensions

    def parse_publisher(self, response):
        publisher = response.xpath("//dl[contains(text(),'Издательство')]/following::dd[1]/a/text()").extract_first()
        return publisher

    def parse_publishing_year(self, response):
        publishing_year = response.xpath("//dl[contains(text(),'Год')]/following::dd[1]/text()").extract_first()
        return publishing_year

    def parse_isbn(self, response):
        isbn = response.xpath("//dl[contains(text(),'ISBN')]/following::dd[1]/text()").extract_first()
        return isbn

    def parse_image_urls(self, response):
        image_url = response.xpath("//div[@class='mainimage']/img/@src").extract_first()
        image_url = response.urljoin(image_url)
        image_urls = [image_url]
        return image_urls

    def parse_weight(self, response):
        weight = response.xpath("//dl[contains(text(),'Вес, г')]/following::dd[1]/text()").extract_first()
        return weight

