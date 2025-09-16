export const downloadFile = (url, filename = null) => {
    return new Promise((resolve, reject) => {
        fetch(url)
            .then(response => response.blob())
            .then(blob => {
                const downloadUrl = window.URL.createObjectURL(blob)
                const link = document.createElement('a')
                link.href = downloadUrl
                link.download = filename || url.split('/').pop() || 'download'
                link.click()
                window.URL.revokeObjectURL(downloadUrl)
                resolve(true)
            })
            .catch(reject)
    })
}
