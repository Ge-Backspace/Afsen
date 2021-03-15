const middleware = {}

middleware['admin'] = require('..\\middleware\\admin.js')
middleware['admin'] = middleware['admin'].default || middleware['admin']

middleware['lapor'] = require('..\\middleware\\lapor.js')
middleware['lapor'] = middleware['lapor'].default || middleware['lapor']

export default middleware
