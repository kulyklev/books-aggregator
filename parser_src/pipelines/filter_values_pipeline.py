import re
import unicodedata


class FilterValuesPipeline(object):

    def process_item(self, item, spider):
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
        item['publishing_year'] = self.filter_int_value(item['publishing_year'])
        item['isbn'] = self.normalize_str_value(item['isbn'])
        item['weight'] = self.filter_int_value(item['weight'])

        spider.logger.critical(item)
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