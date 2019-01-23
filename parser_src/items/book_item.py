import scrapy


class BookItem(scrapy.Item):
    name = scrapy.Field()
    original_name = scrapy.Field()
    author = scrapy.Field()
    price = scrapy.Field()
    currency = scrapy.Field()
    language = scrapy.Field()
    original_language = scrapy.Field()
    paperback = scrapy.Field()
    product_dimensions = scrapy.Field()
    publisher = scrapy.Field()
    publishing_year = scrapy.Field()
    isbn = scrapy.Field()
    link = scrapy.Field()
    image_urls = scrapy.Field()
    images = scrapy.Field()
    pass
