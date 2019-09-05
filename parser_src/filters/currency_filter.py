from filters.filter_decorator import FilterDecorator


class CurrencyFilter(FilterDecorator):

    def filter(self, value) -> str:
        filtered_value = self._valueFilter.filter(value)

        if filtered_value == "грн":
            return "UAH"
        elif filtered_value == "UAH":
            return filtered_value
        else:
            # TODO Add logging warning
            # spider.logger.warning("Unknown currency: %s" % filtered_value)
            pass