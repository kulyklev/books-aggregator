import json
import pika
from items.book_item import BookItem
from items.reparsed_book_item import ReparsedBookItem

from parser_src.settings import RABBITMQ_LOGIN, RABBITMQ_PASSWORD, RABBITMQ_HOST, RABBITMQ_PORT


class SaveItemsPipeline(object):

    def process_item(self, item, spider):
        book = None

        if isinstance(item, BookItem):
            book = self.process_book_item(item, spider)
        elif isinstance(item, ReparsedBookItem):
            book = self.process_reparsed_book_item(item, spider)

        self.send_item_to_queue(book)
        return item

    def process_book_item(self, item: BookItem, spider):
        book = {
            'data_type': 'bookItem',
            'name': item['name'],
            'original_name': item['original_name'],
            'author': item['author'],
            'price': item['price'],
            'currency': item['currency'],
            'language': item['language'],
            'original_language': item['original_language'],
            'paperback': item['paperback'],
            'product_dimensions': item['product_dimensions'],
            'publisher': item['publisher'],
            'publishing_year': item['publishing_year'],
            'isbn': item['isbn'],
            'link': item['link'],
            'image': item['images'],
            'weight': item['weight'],
            'dealer_name': spider.name,
            'category_id': spider.category_id
        }
        return book

    def process_reparsed_book_item(self, item: ReparsedBookItem, spider):
        book = {
            'data_type': 'reparsedPrice',
            'isbn': item['isbn'],
            'price': item['price'],
            'currency': item['currency'],
            'dealer_name': spider.name,
        }
        return book

    def send_item_to_queue(self, item):
        credentials = pika.PlainCredentials(RABBITMQ_LOGIN, RABBITMQ_PASSWORD)
        connection = pika.BlockingConnection(pika.ConnectionParameters(host=RABBITMQ_HOST, port=RABBITMQ_PORT, credentials=credentials))
        channel = connection.channel()

        channel.queue_declare(queue='save_book', durable=True)

        message = json.dumps(item)

        channel.basic_publish(exchange='',
                              routing_key='save_book',
                              body=message,
                              properties=pika.BasicProperties(
                                  delivery_mode=2,  # make message persistent
                              ))

        connection.close()
        pass