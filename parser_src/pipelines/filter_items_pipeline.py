# -*- coding: utf-8 -*-

# Define your item pipelines here
#
# Don't forget to add your pipeline to the ITEM_PIPELINES setting
# See: https://doc.scrapy.org/en/latest/topics/item-pipeline.html
from scrapy.exceptions import DropItem
from items.book_item import BookItem
# from parser_src.items.book_item import BookItem


class FilterItemsPipeline(object):
    def process_item(self, item, spider):
        if not self.has_isbn(item):
            raise DropItem("Missing ISBN in %s" % item)
        elif self.has_multiple_isbns(item):
            raise DropItem("Two or more ISBNs in %s" % item)
        else:
            return item

    def has_isbn(self, item: BookItem) -> bool:
        if item['isbn'] is None:
            return False
        else:
            return True

    def has_multiple_isbns(self, item) -> bool:
        if "," not in item['isbn']:
            return False
        else:
            return True

