from typing import Optional
from filters.filter_decorator import FilterDecorator


class WhitespaceFilter(FilterDecorator):

    def filter(self, value) -> Optional[str]:
        filtered_value = self.filter(value)

        if filtered_value is not None and isinstance(filtered_value, str):
            return filtered_value.replace(" ", "")
        else:
            return None

