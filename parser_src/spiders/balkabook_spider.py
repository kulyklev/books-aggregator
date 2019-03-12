import scrapy
import logging

from parsers.balkabook_parser import BalkaBookParser
# from parser_src.parsers.balka-book_parser import BalkaBookParser


class BalkaBookSpider(scrapy.Spider):

    name = "balka-book.com"
    allowed_domains = ["balka-book.com"]
    book_url = None
    category_id = None
    custom_settings = {
        'LOG_FILE': 'logs/balka-book.txt',
    }

    # If start_url and book_url are given then book_url will be processed as more prior task
    def __init__(self, category_id=None, start_url=None, book_url=None, *args, **kwargs):
        console = logging.StreamHandler()
        console.setLevel(logging.DEBUG)
        logging.getLogger('').addHandler(console)
        super().__init__(**kwargs)
        self.category_id = category_id
        self.start_url = start_url
        self.book_url = book_url

    def start_requests(self):
        if self.book_url is not None:
            return [scrapy.FormRequest(self.book_url,
                                       callback=self.reparse_book)]
        elif self.start_url is not None:
            return [scrapy.FormRequest(self.start_url,
                                       callback=self.generate_requests)]

    def reparse_book(self, response):
        balkabook_parser = BalkaBookParser()
        yield balkabook_parser.reparse_book_page(response)

    def generate_requests(self, response):
        number_of_pages_in_category = self.get_number_of_pages_in_category(response)

        if number_of_pages_in_category is None:
            yield scrapy.Request(self.start_url,
                                 callback=self.parse,
                                 dont_filter=True)
        else:
            requests = self.generate_urls(number_of_pages_in_category)
            for i, request in enumerate(requests):
                # If statement needed to perform request with 'start_url' second time
                if i == 0:
                    yield scrapy.Request(request,
                                         callback=self.parse,
                                         dont_filter=True)
                else:
                    yield scrapy.Request(request,
                                         callback=self.parse)

    def get_number_of_pages_in_category(self, response) -> int:
        number_of_pages = response.xpath("//div[@class='links']/a[position() = last()]/text()").extract_first()
        if number_of_pages is None:
            return 1
        else:
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