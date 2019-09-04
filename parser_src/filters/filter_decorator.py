from filters.value_filter import ValueFilter


class FilterDecorator(ValueFilter):

    _valueFilter = None

    def __init__(self, value_filter: ValueFilter) -> None:
        self._valueFilter = value_filter

    def get_value_filter(self):
        return self._valueFilter

    def filter(self, value):
        return self._valueFilter.filter(value)