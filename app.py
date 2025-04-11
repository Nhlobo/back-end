from flask import Flask, request, render_template

app = Flask(__name__)

@app.route('/')
def home():
    return 'Backend is running!'

@app.route('/pay', methods=['POST'])
def pay():
    return render_template('payfast_form.html', data=request.form)

@app.route('/notify', methods=['POST'])
def notify():
    # You can log the result or handle IPN response here
    print("Payment Notification Received:", request.form)
    return '', 200
