const CLIENT = 'PAYPAL_PRODUCTION_CLIENT_ID';
const SECRET = 'PAYPAL_PRODUCTION_SECRET';

server.post('/my-api/execute-payment', async function(req, res) {
  let paymentID = req.body.paymentID;
  let payerID = req.body.payerID;

  let oauth = await request.post({
    uri:  'https://api.paypal.com/v1/oauth2/token',
    body: 'grant_type=client_credentials',
    auth: { user: CLIENT, pass: SECRET }
  });

  let payment = await request.post({
    uri:  `https://api.paypal.com/v1/payments/payment/${paymentID}/execute`,
    auth: { bearer: oauth.access_token },
    json: true,
    body: { payer_id: payerID }
  });

  res.json({ status: 'success' });
});