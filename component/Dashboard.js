import React, { Component } from 'react'
import { Text, View, StyleSheet, Pressable, SafeAreaView,ScrollView, RefreshControl} from 'react-native'
import AppBar from './AppBar'
import { FAB,List } from 'react-native-paper';
import 'react-native-gesture-handler';
import axios from 'axios';

import ResumeCard from './ResumeCard';
import ProfileDetails from './ProfileDetails';
import { HOST } from './config';

import ActivityLoading from './ActivityLoading';
import { ERContext } from '../ERContext';
//import { color } from 'react-native-reanimated';
//import { ScrollView } from 'react-native-gesture-handler';

export class Dashboard extends Component {
    constructor(props) {
        super(props)
    
        this.state = {
             itemsCount:1,
             resumes:[],
             showLoading:true,
             refreshing:false
        }
    }
    
    componentDidMount = ()=>{
        this._fetchResumes();
    }

    _onRefresh = ()=>{
        this.setState({refreshing:true});
        this._fetchResumes();
    }

    _fetchResumes = async() => {

        if(this.context.isConnected){
            console.log(this.context.token);
            try{
                const response = await axios.post(HOST + '/resumes',{},{
                    headers:{
                        "Authorization":this.context.token,
                    }
                });

                if(response.status === 200){
                    console.log(response.data);
                    if(response.data.success === true){
                        console.log('---------------------resumes----------------');
                        console.log(response.data.data);
                        this.setState({resumes:response.data.data});
                    }else{
                        alert('Someting went wrong! Please restart the app');
                    }
                }else{
                    alert('401');
                }
    
            }catch(error){
                console.log(error);
            }
        }else{
            alert('no network');
        }
        this.setState({showLoading:false,refreshing:false});
        
    }

    
    render() {
       //const userNav = createDrawerNavigator();

       let { navigation } = this.props;
       //console.log(this.state.resumes);
        if(this.state.showLoading)
            return <ActivityLoading msg ="Loading"/>
        else
        return (
            <>
                <FAB
                    style={styles.fab}
                    icon="plus"
                    color="#ffffff"
                    onPress={()=>this.props.navigation.push('Profile')}
                />
                
                {this.state.resumes.length === 0 ?
                    <View style={styles.noResumeContainer}>
                        <Text style={styles.noResumeText}>
                        You have not created any resume.
                        To create one click on plus (+) button
                        </Text>
                    </View>
                    :
                    // Resumes
                    <ScrollView
                        showsVerticalScrollIndicator={false}
                        refreshControl={
                            <RefreshControl 
                                refreshing={this.state.refreshing}
                                onRefresh={this._onRefresh}
                                enabled={true}
                                colors={['rgba(245,148,183,1)', 'rgba(173,127,251,1)','rgba(146,178,253,1)']}
                                />
                        }>
                        <View style={styles.resumeContainer}>
                            {
                                this.state.resumes.map((resume, index)=>{
                                    return <Pressable
                                                key={index}
                                                onPress={()=>{this.props.navigation.push('Preview',{resume:resume})}}
                                            >
                                                <ResumeCard name={resume.name} email={resume.email} image={resume.image} resumeNo={resume.resumeNo}/>
                                            </Pressable>
                                })
                            }
                        </View>
                    </ScrollView>
                }
                </>

        )
    }
}


const styles = StyleSheet.create({
    fab: {
      position: 'absolute',
      margin: 25,
      right: 0,
      bottom: 0,
      backgroundColor: '#92B2FD',
      zIndex: 1
    },
    noResumeContainer:{
        flex: 1,
        justifyContent: 'center',
        alignItems:'center',
    },
    noResumeText:{
        textAlign:'center',
        fontSize: 16,
        fontWeight: '600',
        color: '#444444',
        margin: 40,
    },
    resumeContainer:{
        paddingVertical: 15,
        flex: 1,
        justifyContent: 'flex-start',
        alignItems:'center',
        backgroundColor: '#CCD0F6',
        paddingHorizontal: 15,
    },
  })



Dashboard.contextType = ERContext;
export default Dashboard
