import re

from typing import Optional
from filters.filter_decorator import FilterDecorator


class IntFilter(FilterDecorator):

    def filter(self, value) -> Optional[int]:
        filtered_value = self._valueFilter.filter(value)

        if filtered_value is not None and isinstance(filtered_value, str):
            return int(re.search(r'\d+', filtered_value).group())
        else:
            return None