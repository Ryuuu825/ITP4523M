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
    price = int(str(request.args.get('discount')))
    if price >= 3000:
        return {"discount": 0.03}
    elif price >= 5000:
        return {"discount": 0.08}
    elif price >= 10000:
        return {"discount": 0.12}
    else:
        return {"discount": 0}

app.run()