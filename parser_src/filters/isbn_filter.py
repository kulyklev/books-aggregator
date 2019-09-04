import re

from filters.filter_decorator import FilterDecorator


class IsbnFilter(FilterDecorator):

    # This function normalizes isbn value and if ISBN contains two or more values, then returns only first one.
    # It works this way, because I don`t have any idea how to store books with several ISBNs
    def filter(self, value):
        isbn = re.split("[,# ]", value)
        return isbn[0]