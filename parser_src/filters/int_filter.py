import re

from filters.filter_decorator import FilterDecorator


class IntFilter(FilterDecorator):
    def filter(self, value):
        if value is not None:
            return int(re.search(r'\d+', value).group())
        else:
            return None