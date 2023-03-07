const sendRequest = async (method, url, data, header = {}) => {
    let request
    if (method === 'GET') {
        request = await fetch(url, {
            headers: {
                ...header, 
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            }
        })
    }
    else {
        request = await fetch(url, {
            method: method,
            headers: {
                ...header,
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            },
            body: JSON.stringify(data)
        })
    }
    
    return await request.json()
}

export { sendRequest }