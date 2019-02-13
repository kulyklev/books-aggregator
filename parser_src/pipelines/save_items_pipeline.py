import json
import pika


class SaveItemsPipeline(object):

    def process_item(self, item, spider):
        book = {
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
            'image_urls': item['image_urls'],
            'weight': item['weight']
        }

        spider.logger.critical(item)
        self.send_item_to_queue(item)

        return item

    def send_item_to_queue(self, item):
        connection = pika.BlockingConnection(pika.ConnectionParameters(host='rabbitmq'))
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