from abc import ABC
from filters.filter import Filter


class FilterDecorator(ABC, Filter):

    _valueFilter = None

    def __init__(self, value_filter: Filter) -> None:
        self._valueFilter = value_filter

    # def get_value_filter(self):
    #     return self._valueFilter
    #
    # def filter(self, value):
    #     return self._valueFilter.filter(value)