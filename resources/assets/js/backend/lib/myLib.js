import qs from 'qs'
import {POST, PUT} from 'config/api'

/**
 * create api request body
 * @param method
 * @param uri
 * @param data
 * @param header
 * @returns {{url: string, headers, method: string, responseType: string, withCredentials: boolean}}
 */
export function createApiBody(method = 'get', uri = '', data = {}, header = {}) {
    let res = {
        url: replaceMatchData(uri, data),
        headers: header,
        method,
        responseType: 'json'
    }
    const isSendData = method === PUT || method === POST
    const dataProperty = isSendData
        ? 'data'
        : 'params'
    res[dataProperty] = isSendData
        ? qs.stringify(data)
        : data
    return res
}

/**
 * find the key match in uri and replace it
 * ex. uri: '/aa/{id}', data: {a: 'a', id: 1}
 * result. /aa/1 data: {a: 'a'}
 * @param uri
 * @param data
 * @returns {*}
 */
function replaceMatchData(uri, data) {
    var ts = uri.match(/({[\w]+})/g)
    if (ts) {
        ts.forEach(key => {
            key = key.replace(/[{}]/g, '')
            if (data[key]) {
                uri = uri.replace(`{${key}}`, data[key])
                delete data[key]
            }
        })
    }
    return uri
}

/**
 * root to parse json at api result
 * @param val
 * @returns {*}
 */
export function roopParse(val) {
    if (_.isObject(val) || _.isArray(val)) {
        _.forEach(val, (v, k) => {
            val[k] = roopParse(v)
        })
        return val
    }
    else {
        if (typeof val === 'string' && _.includes(val.substr(0, 2), '{', '[')) {
            try {
                return JSON.parse(val)
            }
            catch (err) {
                return val
            }
        }
        else {
            return val
        }
    }
}

export const getUrlParameter = name => {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    var results = regex.exec(location.search);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
}

export const urlParse = url => {
    const search = url.split('?')[1]
    url = url.split('?')[0]
    const res = {}
    const params = search.split('&')
    _.forEach(params, param => {
        res[param.split('=')[0]] = param.split('=')[1]
    })
    return {
        url, params: res
    }
}

export const formSubmit = (url, params, method = 'post') => {
    const form = document.createElement('form')
    form.method = method
    form.action = url
    for (const key in params) {
        if (params.hasOwnProperty(key)) {
            const hiddenField = document.createElement('input');
            hiddenField.type = 'hidden';
            hiddenField.name = key;
            hiddenField.value = params[key];
            form.appendChild(hiddenField);
        }
    }
    document.body.appendChild(form);
    form.submit();
}
