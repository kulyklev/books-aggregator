import scrapy
import logging

from parsers.yakabooua_parser import YakaboouaParser
# from parser_src.parsers.yakabooua_parser import YakaboouaParser


class YakaboouaSpider(scrapy.Spider):

    name = "yakaboo.ua"
    allowed_domains = ["yakaboo.ua"]
    start_url = "https://www.yakaboo.ua/knigi/komp-juternaja-literatura.html"
    custom_settings = {
        'LOG_FILE': 'logs/yakabooua.txt',
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
        number_of_pages = response.xpath("//a[@class='last']/text()").extract_first()
        if number_of_pages is None:
            return 1
        else:
            return int(number_of_pages)

    def generate_urls(self, number_of_pages_in_category):
        return (self.start_url + "?p=" + str(i) for i in range(1, number_of_pages_in_category + 1))

    def parse(self, response):
        pagination = self.get_pagination_items(response)
        for book_href in pagination:
            book_page_url = response.urljoin(book_href)
            yield scrapy.Request(book_page_url,
                                 callback=self.parse_pagination)

    def get_pagination_items(self, response):
        # TODO Maybe replace this method to YakabooParser class
        return response.xpath("//tr[@class='name']/td/a/@href").extract()

    def parse_pagination(self, response):
        yakabooua_parser = YakaboouaParser()
        yield yakabooua_parser.parse_book_page(response)