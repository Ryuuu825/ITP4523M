from flask import Flask, url_for, request

app = Flask(__name__)


@app.route('/')
def usage():
    return '''
    Usage:
    /api/discountCalculator
    '''

@app.route("/api/discountCalculator" , methods=['GET'])
def discountCalculator():
    price = int(request.args.get('discount'))
    if price >= 3000:
        price = price * 1.03
    elif price >= 5000:
        price = price * 1.08
    elif price >= 10000:
        price = price * 1.12
    else:
        price = price

    return str(price)

app.run()