import scrapy
import logging
from items.book_item import BookItem


class BookclubSpider(scrapy.Spider):
    name = "bookclub.ua"
    allowed_domains = ["bookclub.ua"]
    custom_settings = {
        'LOG_FILE': 'logs/bookclub.txt',
    }

    def __init__(self, *args, **kwargs):
        console = logging.StreamHandler()
        console.setLevel(logging.DEBUG)
        logging.getLogger('').addHandler(console)
        super().__init__(**kwargs)

    def start_requests(self):
        return [scrapy.FormRequest("https://www.bookclub.ua/catalog/books/pop/",
                                   callback=self.parse)]

    def parse(self, response):
        pagination = response.xpath("//div[@class='book-inlist-name']/a/@href").extract()

        for book_hef in pagination:
            book_page_url = response.urljoin(book_hef)
            yield scrapy.Request(book_page_url,
                                 callback=self.parse_book_page)

    def parse_book_page(self, response):
        book_item = BookItem()

        book_item['name'] = self.parse_name(response)
        book_item['author'] = self.parse_author(response)
        book_item['language'] = self.parse_language(response)
        book_item['original_language'] = self.parse_original_language(response)
        book_item['paperback'] = self.parse_paperback(response)
        book_item['product_dimensions'] = self.parse_product_dimensions(response)
        book_item['publisher'] = self.parse_publisher(response)
        book_item['publishing_year'] = self.parse_publishing_year(response)
        book_item['isbn'] = self.parse_isbn(response)
        book_item['link'] = response.url
        book_item['image_urls'] = self.parse_image_urls(response)

        yield book_item

    def parse_name(self, response):
        name = response.xpath("//div[contains(text(),'Название товара')]/following::div[1]/text()").extract_first()
        return name

    def parse_author(self, response):
        author = response.xpath("//div[contains(text(),'Aвтор')]/following::div[1]/text()").extract_first()
        return author

    def parse_language(self, response):
        language = response.xpath("//div[contains(text(),'Язык')]/following::div[1]/text()").extract_first()
        return language

    def parse_original_language(self, response):
        original_language = response.xpath("//div[contains(text(),'Обложка')]/following::div[1]/text()").extract_first()
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
        publishing_year = response.xpath("//div[contains(text(),'Год издания')]/following::div[1]/a/text()").extract_first()
        return publishing_year

    def parse_isbn(self, response):
        isbn = response.xpath("//div[contains(text(),'ISBN')]/following::div[1]/text()").extract_first()
        return isbn

    def parse_image_urls(self, response):
        image_urls = response.xpath("//div[@class='prd-image']/img/@src").extract()
        return image_urls
