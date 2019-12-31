from abc import ABC, abstractmethod

import scrapy
import logging


class BaseSpider(scrapy.Spider, ABC):

    @property
    @abstractmethod
    def name(self):
        pass

    @property
    @abstractmethod
    def allowed_domains(self) -> list:
        pass

    book_url = None
    category_id = None

    @property
    @abstractmethod
    def custom_settings(self) -> dict:
        pass

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
        else:
            self.logger.error('Book url and start url are empty')

    @abstractmethod
    def reparse_book(self, response):
        pass

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

    @abstractmethod
    def get_number_of_pages_in_category(self, response) -> int:
        pass

    @abstractmethod
    def generate_urls(self, number_of_pages_in_category):
        pass

    def parse(self, response):
        pagination = self.get_pagination_items(response)
        for book_href in pagination:
            book_page_url = response.urljoin(book_href)
            yield scrapy.Request(book_page_url,
                                 callback=self.parse_pagination)

    @abstractmethod
    def get_pagination_items(self, response):
        pass

    @abstractmethod
    def parse_pagination(self, response):
        pass