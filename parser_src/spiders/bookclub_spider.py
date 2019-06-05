from parsers.bookclub_parser import BookclubParser
# from parser_src.parsers.bookclub_parser import BookclubParser
from spiders.base_spider import BaseSpider


class BookclubSpider(BaseSpider):

    name = "bookclub.ua"
    allowed_domains = ["bookclub.ua"]
    book_url = None
    category_id = None
    custom_settings = {
        'LOG_FILE': 'logs/bookclub.txt',
    }

    def reparse_book(self, response):
        bookclub_parser = BookclubParser()
        yield bookclub_parser.reparse_book_page(response)

    def get_number_of_pages_in_category(self, response) -> int:
        number_of_pages = response.xpath("//a[@class='navClick'][position() = last()]/div/text()").extract_first()
        if number_of_pages is None:
            return 1
        else:
            return int(number_of_pages)

    def generate_urls(self, number_of_pages_in_category):
        for i in range(number_of_pages_in_category):
            last_book_index = 100 * i
            yield self.start_url + "?gc=100&i=" + str(last_book_index) + "&listmode=2"

    def get_pagination_items(self, response):
        # TODO Maybe replace this method to BookclubParser class
        return response.xpath("//div[@class='book-inlist-name']/a/@href").extract()

    def parse_pagination(self, response):
        bookclub_parser = BookclubParser()
        yield bookclub_parser.parse_book_page(response)