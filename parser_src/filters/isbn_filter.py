import re

from typing import Optional
from filters.filter_decorator import FilterDecorator


class IsbnFilter(FilterDecorator):

    # This function normalizes isbn value and if ISBN contains two or more values, then returns only first one.
    # It works this way, because I don`t have any idea how to store books with several ISBNs
    def filter(self, value) -> Optional[str]:
        filtered_value = self.filter(value)

        if filtered_value is not None and isinstance(filtered_value, str):
            isbn = re.split("[,# ]", filtered_value)
            return isbn[0]
        else:
            return None

