from filters.filter_decorator import FilterDecorator


class WhitespaceFilter(FilterDecorator):
    def filter(self, value):
        return value.replace(" ", "")