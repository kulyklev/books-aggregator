import re
import unicodedata

from filters.filter_decorator import FilterDecorator


class StringFilter(FilterDecorator):
    def filter(self, value: str) -> str:
        if value is not None:
            value = unicodedata.normalize("NFKD", value)
            value = re.sub(r"\s+", ' ', value)
            return value.strip()
        else:
            pass