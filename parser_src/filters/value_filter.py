from abc import ABC, abstractmethod


class ValueFilter(ABC):

    @abstractmethod
    def filter(self, value):
        pass