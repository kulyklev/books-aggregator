import scrapy
import logging

from parsers.bookclub_parser import BookclubParser
# from parser_src.parsers.bookclub_parser import BookclubParser


class BookclubSpider(scrapy.Spider):

    name = "bookclub.ua"
    allowed_domains = ["bookclub.ua"]
    start_url = "https://www.bookclub.ua/catalog/books/learning/?gc=100"
    custom_settings = {
        'LOG_FILE': 'logs/bookclub.txt',
    }

    def __init__(self, *args, **kwargs):
        console = logging.StreamHandler()
        console.setLevel(logging.DEBUG)
        logging.getLogger('').addHandler(console)
        super().__init__(**kwargs)

    def start_requests(self):
        return [scrapy.FormRequest("https://www.bookclub.ua/catalog/books/learning/?gc=100",
                                   callback=self.parse)]

    def generate_requests(self, response):
        number_of_pages_in_category = self.get_number_of_pages_in_category(response)
        requests = self.generate_urls(number_of_pages_in_category)
        for request in requests:
            yield scrapy.Request(request,
                                 callback=self.parse)

    def get_number_of_pages_in_category(self, response):
        number_of_pages = response.xpath("//a[@class='navClick'][position() = last()]/div")
        return int(number_of_pages)

    def generate_urls(self, number_of_pages_in_category):
        for i in range(1, number_of_pages_in_category):
            last_book_index = 100 * i
            yield self.start_url + "&i=" + str(last_book_index) + "&listmode=2"

    def parse(self, response):
        pagination = self.get_pagination_items(response)

        for book_href in pagination:
            book_page_url = response.urljoin(book_href)
            yield scrapy.Request(book_page_url,
                                 callback=self.parse_pagination)

    def get_pagination_items(self, response):
        # TODO Maybe replace this method to YakabooParser class
        return response.xpath("//div[@class='book-inlist-name']/a/@href").extract()

    def parse_pagination(self, response):
        bookclub_parser = BookclubParser()
        yield bookclub_parser.parse_book_page(response)