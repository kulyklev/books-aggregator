from filters.authors_arr_filter import AuthorsArrFilter
from filters.currency_filter import CurrencyFilter
from filters.int_filter import IntFilter
from filters.isbn_filter import IsbnFilter
from filters.price_filter import PriceFilter
from filters.string_filter import StringFilter
from filters.value_filter import ValueFilter
from filters.whitespace_filter import WhitespaceFilter
from filters.year_filter import YearFilter
from items.book_item import BookItem
from items.reparsed_book_item import ReparsedBookItem


class FilterValuesPipeline(object):

    def process_item(self, item, spider):
        if isinstance(item, BookItem):
            book = self.process_book_item(item, spider)
        elif isinstance(item, ReparsedBookItem):
            book = self.process_reparsed_book_item(item, spider)

        return book

    def process_book_item(self, item: BookItem, spider):
        string_filter = StringFilter(ValueFilter())
        whitespace_filter = WhitespaceFilter(string_filter)
        int_filter = IntFilter(whitespace_filter)

        item['name'] = string_filter.filter(item['name'])
        item['original_name'] = string_filter.filter(item['original_name'])
        item['author'] = AuthorsArrFilter(string_filter).filter(item['author'])
        item['price'] = PriceFilter(whitespace_filter).filter(item['price'])
        item['currency'] = CurrencyFilter(whitespace_filter).filter(item['currency'])
        item['language'] = string_filter.filter(item['language'])
        item['original_language'] = string_filter.filter(item['original_language'])
        item['paperback'] = int_filter.filter(item['paperback'])
        item['product_dimensions'] = string_filter.filter(item['product_dimensions'])
        item['publisher'] = string_filter.filter(item['publisher'])
        item['publishing_year'] = YearFilter(int_filter).filter(item['publishing_year'])
        item['isbn'] = IsbnFilter(string_filter).filter(item['isbn'])
        item['weight'] = int_filter.filter(item['weight'])

        spider.logger.critical(item)

        return item

    def process_reparsed_book_item(self, item: ReparsedBookItem, spider):
        string_filter = StringFilter(ValueFilter())
        whitespace_filter = WhitespaceFilter(string_filter)

        item['price'] = PriceFilter(whitespace_filter).filter(item['price'])
        item['currency'] = CurrencyFilter(whitespace_filter).filter(item['currency'])
        item['isbn'] = IsbnFilter(string_filter).filter(item['isbn'])

        return item