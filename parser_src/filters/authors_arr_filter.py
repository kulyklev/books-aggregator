from filters.filter_decorator import FilterDecorator


class AuthorsArrFilter(FilterDecorator):

    def filter(self, value) -> list:
        res = []
        for item in value:
            res.append(self._valueFilter.filter(item))

        return res