const middleware = {}

middleware['lapor'] = require('..\\middleware\\lapor.js')
middleware['lapor'] = middleware['lapor'].default || middleware['lapor']

export default middleware
