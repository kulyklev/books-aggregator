import datetime
import re
import unicodedata
from typing import Optional

from items.book_item import BookItem
from items.reparsed_book_item import ReparsedBookItem


class FilterValuesPipeline(object):

    def process_item(self, item, spider):
        if isinstance(item, BookItem):
            book = self.process_book_item(item, spider)
        elif isinstance(item, ReparsedBookItem):
            book = self.process_reparsed_book_item(item, spider)

        return item

    def process_book_item(self, item: BookItem, spider):
        item['name'] = self.normalize_str_value(item['name'])
        item['original_name'] = self.normalize_str_value(item['original_name'])
        item['author'] = self.normalize_arr_of_strs(item['author'])
        item['price'] = self.filter_price(item['price'])
        item['currency'] = self.filter_currency(item['currency'], spider)
        item['language'] = self.normalize_str_value(item['language'])
        item['original_language'] = self.normalize_str_value(item['original_language'])
        item['paperback'] = self.filter_int_value(item['paperback'])
        item['product_dimensions'] = self.normalize_str_value(item['product_dimensions'])
        item['publisher'] = self.normalize_str_value(item['publisher'])
        item['publishing_year'] = self.is_valid_year(item['publishing_year'])
        item['isbn'] = self.normalize_isbn(item['isbn'])
        item['weight'] = self.filter_int_value(item['weight'])
        return item

    def process_reparsed_book_item(self, item: ReparsedBookItem, spider):
        item['price'] = self.filter_price(item['price'])
        item['currency'] = self.filter_currency(item['currency'], spider)
        item['isbn'] = self.normalize_isbn(item['isbn'])
        return item

    def normalize_str_value(self, value: str) -> str:
        if value is not None:
            value = unicodedata.normalize("NFKD", value)
            value = re.sub(r"\s+", ' ', value)
            return value.strip()
        else:
            pass

    def normalize_arr_of_strs(self, arr: list) -> list:
        res = []
        for item in arr:
            res.append(self.normalize_str_value(item))
        return res

    def filter_price(self, value: str) -> float:
        price = self.clear_string(value)
        price = re.findall("\d+\.\d+|\d+", price)
        return float(price[0])

    def clear_string(self, value: str) -> str:
        value = self.normalize_str_value(value)
        return value.replace(" ", "")

    def filter_currency(self, value: str, spider) -> str:
        value = self.clear_string(value)
        if value == "грн":
            return "UAH"
        elif value == "UAH":
            return value
        else:
            spider.logger.warning("Unknown currency: %s" % value)
            pass

    def filter_int_value(self, value: str) -> int:
        if value is not None:
            value = self.clear_string(value)
            return int(re.search(r'\d+', value).group())
        else:
            pass

    def is_valid_year(self, value: str) -> Optional[int]:
        year = self.filter_int_value(value)
        # 1901 is the min year which can receive MySQL the YEAR type
        if 1901 < year < datetime.datetime.now().year:
            return year
        else:
            return None

    # This function normalizes isbn value and if ISBN contains two or more values, then returns only first one.
    # Because, I don`t have any idea how to store books with several ISBNs
    def normalize_isbn(self, value: str) -> str:
        isbn = self.normalize_str_value(value)
        isbn = re.split("[,# ]", isbn)
        return isbn[0]