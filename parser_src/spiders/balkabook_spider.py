import scrapy
import logging

from parsers.balkabook_parser import BalkaBookParser
# from parser_src.parsers.balka-book_parser import BalkaBookParser


class BalkaBookSpider(scrapy.Spider):

    name = "balka-book.com"
    allowed_domains = ["balka-book.com"]
    start_url = "https://balka-book.com/kompyuternaya-literatura-596"
    custom_settings = {
        'LOG_FILE': 'logs/balka-book.txt',
    }

    def __init__(self, *args, **kwargs):
        console = logging.StreamHandler()
        console.setLevel(logging.DEBUG)
        logging.getLogger('').addHandler(console)
        super().__init__(**kwargs)

    def start_requests(self):
        return [scrapy.FormRequest(self.start_url,
                                   callback=self.generate_requests)]

    def generate_requests(self, response):
        number_of_pages_in_category = self.get_number_of_pages_in_category(response)
        requests = self.generate_urls(number_of_pages_in_category)
        for request in requests:
            yield scrapy.Request(request,
                                 callback=self.parse)

    def get_number_of_pages_in_category(self, response):
        number_of_pages = response.xpath("//div[@class='links']/a[position() = last()]/text()").extract_first()
        return int(number_of_pages)

    def generate_urls(self, number_of_pages_in_category):
        return (self.start_url + "/page=" + str(i) for i in range(1, number_of_pages_in_category + 1))

    def parse(self, response):
        pagination = self.get_pagination_items(response)
        for book_href in pagination:
            book_page_url = response.urljoin(book_href)
            yield scrapy.Request(book_page_url,
                                 callback=self.parse_pagination)

    def get_pagination_items(self, response):
        # TODO Maybe replace this method to BalkaBookParser class
        return response.xpath("//strong[@class='name']/a/@href").extract()

    def parse_pagination(self, response):
        balkabook_parser = BalkaBookParser()
        yield balkabook_parser.parse_book_page(response)