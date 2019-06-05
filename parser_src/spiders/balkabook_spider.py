from parsers.balkabook_parser import BalkaBookParser
# from parser_src.parsers.balka-book_parser import BalkaBookParser
from spiders.base_spider import BaseSpider


class BalkaBookSpider(BaseSpider):

    name = "balka-book.com"
    allowed_domains = ["balka-book.com"]
    book_url = None
    category_id = None
    custom_settings = {
        'LOG_FILE': 'logs/balka-book.txt',
    }

    def reparse_book(self, response):
        balkabook_parser = BalkaBookParser()
        yield balkabook_parser.reparse_book_page(response)

    def get_number_of_pages_in_category(self, response) -> int:
        number_of_pages = response.xpath("//div[@class='links']/a[position() = last()]/text()").extract_first()
        if number_of_pages is None:
            return 1
        else:
            return int(number_of_pages)

    def generate_urls(self, number_of_pages_in_category):
        return (self.start_url + "/page=" + str(i) for i in range(1, number_of_pages_in_category + 1))

    def get_pagination_items(self, response):
        # TODO Maybe replace this method to BalkaBookParser class
        return response.xpath("//strong[@class='name']/a/@href").extract()

    def parse_pagination(self, response):
        balkabook_parser = BalkaBookParser()
        yield balkabook_parser.parse_book_page(response)