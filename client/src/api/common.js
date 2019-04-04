export function getSearchHotWord(params){
    return  axios.get('/api/meituan/header/searchHotWords.json',params);
}


