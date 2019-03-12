#### Start commands
To start parsing category you need in parsers_src directory run 
`scrapy crawl <scraper_name> -a category_id= -a start_url=`

To reparce price of book run 
`scrapy crawl <scraper_name> -a book_url=`

In case if you provide `-a start_url=` and `-a book_url=` parameters, `-a book_url=` will be processed as more important
parameter.

#### Description of some parsers behavior

I identify each book in my DB by ISBN. But, there are some cases when books  on dealer's site have two or more ISBNs and
 publishers. Usually it's a set of books. I didn`t have a clue how to store them, so I decided to get only first ISBN and
 publisher. Example of such book page 
 https://www.yakaboo.ua/zhitija-svjatyh-svjatitelja-dmitrija-donskogo-komplekt-iz-3-knig.html#tab-attributes