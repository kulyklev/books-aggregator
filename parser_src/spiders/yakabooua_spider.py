from parsers.yakabooua_parser import YakaboouaParser
# from parser_src.parsers.yakabooua_parser import YakaboouaParser
from spiders.base_spider import BaseSpider


class YakaboouaSpider(BaseSpider):

    name = "yakaboo.ua"
    allowed_domains = ["yakaboo.ua"]
    book_url = None
    category_id = None
    custom_settings = {
        'LOG_FILE': 'logs/yakabooua.txt',
    }

    def reparse_book(self, response):
        yakabooua_parser = YakaboouaParser()
        yield yakabooua_parser.reparse_book_page(response)

    def get_number_of_pages_in_category(self, response) -> int:
        number_of_pages = response.xpath("//a[@class='last']/text()").extract_first()
        if number_of_pages is None:
            return 1
        else:
            return int(number_of_pages)

    def generate_urls(self, number_of_pages_in_category):
        return (self.start_url + "?p=" + str(i) for i in range(1, number_of_pages_in_category + 1))

    def get_pagination_items(self, response):
        # TODO Maybe replace this method to YakabooParser class
        return response.xpath("//tr[@class='name']/td/a/@href").extract()

    def parse_pagination(self, response):
        yakabooua_parser = YakaboouaParser()
        yield yakabooua_parser.parse_book_page(response)