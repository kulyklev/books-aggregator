from parsers.base_parser import BaseParser
from items.book_item import BookItem
from items.reparsed_book_item import ReparsedBookItem
# from parser_src.items.book_item import BookItem
# from parser_src.parsers.base_parser import BaseParser
# from parser_src.items.reparsed_book_item import ReparsedBookItem


class KnigoskParser(BaseParser):

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

    def reparse_book_page(self, response):
        book_item = ReparsedBookItem()
        book_item['price'] = self.parse_price(response)
        book_item['currency'] = self.parse_currency(response)
        book_item['isbn'] = self.parse_isbn(response)
        return book_item

    def parse_name(self, response):
        name = response.xpath("//h1[@itemprop='name']/text()").extract_first()
        return name

    def parse_original_name(self, response):
        # TODO I didn`t find this field yet
        return None

    def parse_author(self, response):
        author = response.xpath("//div[@class='author-name']/a/text()").extract_first()
        return author

    def parse_price(self, response):
        price = response.xpath("//div[contains(@class, 'product-shop')]//span[@class='regular-price']/span[@class='price']/text()").extract_first()
        return price.split('&nbsp')

    def parse_currency(self, response):
        price = response.xpath("").extract_first()
        price, currency = price.split('&nbsp')
        return currency

    def parse_language(self, response):
        language = response.xpath("//th[@class='label']/text()[contains(., 'Язык')]/following::td/text()").extract_first()
        return language

    def parse_original_language(self, response):
        # TODO I didn`t find this field yet
        return None

    def parse_paperback(self, response):
        paperback = response.xpath("//th[@class='label']/text()[contains(., 'Страниц')]/following::td[1]/text()").extract_first()
        return paperback

    def parse_product_dimensions(self, response):
        product_dimensions = response.xpath("//th[@class='label']/text()[contains(., 'Размеры')]/following::td[1]/text()").extract_first()
        return product_dimensions

    def parse_publisher(self, response):
        # TODO I didn`t find this field yet
        return None

    def parse_publishing_year(self, response):
        publishing_year = response.xpath("//th[@class='label']/text()[contains(., 'Год издания')]/following::td[1]/text()").extract_first()
        return publishing_year

    def parse_isbn(self, response):
        isbn = response.xpath("//th[@class='label']/text()[contains(., 'ISBN')]/following::td[1]/text()").extract_first()
        return isbn

    def parse_image_urls(self, response):
        image_url = response.xpath("//div[contains(@class, 'product-image-zoom')]/a/@href").extract_first()
        image_url = response.urljoin(image_url)
        image_urls = [image_url]
        return image_urls

    def parse_weight(self, response):
        # TODO I didn`t find this field yet
        return None