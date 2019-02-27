import scrapy


class ReparsedBookItem(scrapy.Item):
    price = scrapy.Field()
    currency = scrapy.Field()
    isbn = scrapy.Field()
    pass
