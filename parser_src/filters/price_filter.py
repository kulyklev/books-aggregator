import re

from typing import Optional
from filters.filter_decorator import FilterDecorator


class PriceFilter(FilterDecorator):

    def filter(self, value) -> Optional[float]:
        filtered_value = self._valueFilter.filter(value)

        if filtered_value is not None and isinstance(filtered_value, str):
            price = re.findall("\d+\.\d+|\d+", filtered_value)
            price = float(price[0])
            return price
        else:
            return None

