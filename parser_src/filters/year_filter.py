import datetime

from filters.filter_decorator import FilterDecorator


class YearFilter(FilterDecorator):

    def filter(self, value):
        filtered_value = self.filter(value)

        if filtered_value is not None and isinstance(filtered_value, int):
            # 1901 is the min year which can receive MySQL the YEAR type
            if 1901 < value < datetime.datetime.now().year:
                return value
            else:
                return None
        else:
            return None