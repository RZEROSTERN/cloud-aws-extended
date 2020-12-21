import firebase from 'firebase/app'
import 'firebase/app'
import 'firebase/auth'
import store from "./store";

const firebaseConfig = {
    apiKey: process.env.MIX_FIREBASE_APIKEY,
    authDomain: process.env.MIX_FIREBASE_AUTHDOMAIN,
    databaseURL: process.env.MIX_FIREBASE_DATABASEURL,
    projectId: process.env.MIX_FIREBASE_PROJECT_ID,
    storageBucket: process.env.MIX_FIREBASE_STORAGEBUCKET,
    messagingSenderId: process.env.MIX_FIREBASE_MESSAGINGSENDERID,
    appId: process.env.MIX_FIREBASE_APPID
};

firebase.initializeApp(firebaseConfig)

firebase.auth().onAuthStateChanged(user => {
    store.dispatch("fetchUser", user);
});

export default firebase