# How to use this Lumen Application

1. Once the application is cloned from the github to local repo, first step is run composer install
2. After composer install, run php artisan serve (Flipbox has been installed to make all artisan commands available to lumen project)

# Run Migrations
3. php artisan migrate

# APIs End Points
Get all products  
http://127.0.0.1:8000/api/v1/products

Show single product with optional parameter to get product stock  
http://127.0.0.1:8000/api/v1/product/1 (Fetch only products)  
http://127.0.0.1:8000/api/v1/product/1/1 (Fetch products and it's stocks)

Delete Product  
http://127.0.0.1:8000/api/v1/product/destroy/2

Create Product (Make sure to provide necessary data)  
http://127.0.0.1:8000/api/v1/product/create

Create Stock  
http://127.0.0.1:8000/api/v1/stock/create

Update Product
http://127.0.0.1:8000/api/v1/product/update/2



