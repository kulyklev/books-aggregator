from filters.filter_decorator import FilterDecorator


class CurrencyFilter(FilterDecorator):

    def filter(self, value):
        if value == "грн":
            return "UAH"
        elif value == "UAH":
            return value
        else:
            # TODO Add logging warning
            # spider.logger.warning("Unknown currency: %s" % value)
            pass