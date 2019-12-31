from scrapy.utils.response import open_in_browser

from parsers.knigosklad_parser import KnigoskladParser
from spiders.base_spider import BaseSpider


class KnigoskladSpider(BaseSpider):

    name = "knigosklad.com.ua"
    allowed_domains = ["knigosklad.com.ua"]
    book_url = None
    category_id = None
    custom_settings = {
        'LOG_FILE': 'logs/knigosklad.txt',
    }

    def reparse_book(self, response):
        knigosklad_parser = KnigoskladParser()
        yield knigosklad_parser.reparse_book_page(response)

    def get_number_of_pages_in_category(self, response) -> int:
        number_of_pages = response.xpath("//div[contains(@class, 'pages')]/ol/li[last()-1]/a/text()").extract_first()
        if number_of_pages is None:
            return 1
        else:
            return int(number_of_pages)

    def generate_urls(self, number_of_pages_in_category):
        urls = (self.start_url + "?p=" + str(i) for i in range(1, number_of_pages_in_category + 1))
        return urls

    def get_pagination_items(self, response):
        # TODO Maybe replace this method to Parser class
        return response.xpath("//a[@class='product-image']/@href").extract()

    def parse_pagination(self, response):
        knigosklad_parser = KnigoskladParser()
        yield knigosklad_parser.parse_book_page(response)