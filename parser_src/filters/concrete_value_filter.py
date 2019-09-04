from filters.value_filter import ValueFilter


class ConcreteValueFilter(ValueFilter):

    def filter(self, value):
        return 'something done'