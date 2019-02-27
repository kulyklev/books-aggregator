import scrapy
import logging

from parsers.bookclub_parser import BookclubParser
# from parser_src.parsers.bookclub_parser import BookclubParser


class BookclubSpider(scrapy.Spider):

    name = "bookclub.ua"
    allowed_domains = ["bookclub.ua"]
    book_url = None
    category_id = None

    custom_settings = {
        'LOG_FILE': 'logs/bookclub.txt',
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
            self.logger.critical('1')
            return [scrapy.FormRequest(self.book_url,
                                       callback=self.reparse_book)]
        elif self.start_url is not None:
            self.logger.critical('2')
            return [scrapy.FormRequest(self.start_url,
                                       callback=self.generate_requests)]

    def reparse_book(self, response):
        bookclub_parser = BookclubParser()
        yield bookclub_parser.reparse_book_page(response)

    def generate_requests(self, response):
        number_of_pages_in_category = self.get_number_of_pages_in_category(response)
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
        number_of_pages = response.xpath("//a[@class='navClick'][position() = last()]/div/text()").extract_first()
        if number_of_pages is None:
            return 1
        else:
            return int(number_of_pages)

    def generate_urls(self, number_of_pages_in_category):
        for i in range(number_of_pages_in_category):
            last_book_index = 100 * i
            yield self.start_url + "&i=" + str(last_book_index) + "&listmode=2"

    def parse(self, response):
        pagination = self.get_pagination_items(response)
        for book_href in pagination:
            book_page_url = response.urljoin(book_href)
            yield scrapy.Request(book_page_url,
                                 callback=self.parse_pagination)

    def get_pagination_items(self, response):
        # TODO Maybe replace this method to BookclubParser class
        return response.xpath("//div[@class='book-inlist-name']/a/@href").extract()

    def parse_pagination(self, response):
        bookclub_parser = BookclubParser()
        yield bookclub_parser.parse_book_page(response)