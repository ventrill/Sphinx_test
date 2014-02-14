# update (save) new (changed) config
sudo cp -v sphinx.conf /etc/sphinxsearch/sphinx.conf

# restart with new config
sudo /etc/init.d/sphinxsearch restart

# rebuild index
sudo indexer --all --rotate

#for test sphinxsearch mysql connection
search 'test'
search 'is my'