# -*- coding: utf-8 -*-

# Define your item pipelines here
#
# Don't forget to add your pipeline to the ITEM_PIPELINES setting
# See: https://doc.scrapy.org/en/latest/topics/item-pipeline.html
from scrapy.exceptions import DropItem


class FilterItemsPipeline(object):
    def process_item(self, item, spider):
        if item['isbn'] is None:
            raise DropItem("Missing ISBN in %s" % item)
        else:
            spider.logger.critical(item)
            return item
