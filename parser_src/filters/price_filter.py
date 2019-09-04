import re

from filters.filter_decorator import FilterDecorator


class PriceFilter(FilterDecorator):
    def filter(self, value: str) -> float:
        price = re.findall("\d+\.\d+|\d+", value)
        price = float(price[0])
        return price