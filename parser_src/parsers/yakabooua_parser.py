from parsers.base_parser import BaseParser
from items.book_item import BookItem
# from parser_src.items.book_item import BookItem

class YakaboouaParser(BaseParser):

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
        name = response.xpath("//h1[@itemprop='description']/text()").extract_first()
        return name

    def parse_original_name(self, response):
        # TODO I didn`t find this field yet
        return None

    def parse_author(self, response):
        author = response.xpath("//table[@id='product-attribute-specs-table']/tbody/tr[td//text()[contains(., 'Автор')]]/td[2]/a/text()").extract_first()
        return author

    def parse_price(self, response):
        price = response.xpath("//div[@id='price_stock_placeholder-top']//span[@itemprop='price']/text()").extract_first()
        return price

    def parse_currency(self, response):
        currency = response.xpath("//div[@id='price_stock_placeholder-top']//span[@class='currency']/text()").extract_first()
        return currency

    def parse_language(self, response):
        language = response.xpath("//table[@id='product-attribute-specs-table']/tbody/tr[td//text()[contains(., 'Язык')]]/td[2]/text()").extract_first()
        return language

    def parse_original_language(self, response):
        # TODO I didn`t find this field yet
        return None

    def parse_paperback(self, response):
        paperback = response.xpath("//table[@id='product-attribute-specs-table']/tbody/tr[td//text()[contains(., 'Количество страниц')]]/td[2]/text()").extract_first()
        return paperback

    def parse_product_dimensions(self, response):
        product_dimensions = response.xpath("//table[@id='product-attribute-specs-table']/tbody/tr[td//text()[contains(., 'Формат')]]/td[2]/text()").extract_first()
        return product_dimensions

    def parse_publisher(self, response):
        # TODO Could be two or more publishers
        publisher = response.xpath("//table[@id='product-attribute-specs-table']/tbody/tr[td//text()[contains(., 'Издательство')]]/td[2]/a/text()").extract_first()
        return publisher

    def parse_publishing_year(self, response):
        publishing_year = response.xpath("//table[@id='product-attribute-specs-table']/tbody/tr[td//text()[contains(., 'Год издания')]]/td[2]/text()").extract_first()
        return publishing_year

    def parse_isbn(self, response):
        # TODO Could be two or more ISBNs
        isbn = response.xpath("//table[@id='product-attribute-specs-table']/tbody/tr[td//text()[contains(., 'ISBN')]]/td[2]/text()").extract_first()
        return isbn

    def parse_image_urls(self, response):
        image_url = response.xpath("//img[@id='image']/@src").extract_first()
        image_url = response.urljoin(image_url)
        image_urls = [image_url]
        return image_urls

    def parse_weight(self, response):
        weight = response.xpath("//table[@id='product-attribute-specs-table']/tbody/tr[td/div//text()[contains(., 'Вес')]]/td[2]/text()").extract_first()
        return weight