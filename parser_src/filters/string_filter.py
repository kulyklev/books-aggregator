import re
import unicodedata

from filters.filter_decorator import FilterDecorator


class StringFilter(FilterDecorator):

    def filter(self, value: str) -> str:
        filtered_value = self._valueFilter.filter(value)

        if filtered_value is not None and isinstance(filtered_value, str):
            filtered_value = unicodedata.normalize("NFKD", filtered_value)
            filtered_value = re.sub(r"\s+", ' ', filtered_value)
            return filtered_value.strip()
        else:
            pass