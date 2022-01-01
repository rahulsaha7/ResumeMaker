import React, { Component } from 'react'
import { Text, View, ScrollView,Image, StyleSheet, Pressable, Alert} from 'react-native'
import { Button,Checkbox } from 'react-native-paper'
import MaterialCommunityIcons from 'react-native-vector-icons/MaterialCommunityIcons';
import { LinearGradient } from 'expo-linear-gradient';


import resumeThumb from './../assets/profile.png'
import { ERContext } from '../ERContext';
import axios from 'axios';
import { HOST } from './config';
import ActivityLoading from './ActivityLoading';
export default class ChooseTemplate extends Component {
    constructor(props) {
        super(props)
    
        this.state = {
             checkid:0,
             templates:[],
             showLoading:true,
        }
    }

    componentDidMount(){
        this._fetchTemplates();
    }


    _fetchTemplates = async() => {

        if(this.context.isConnected){
            //console.log(this.context.token);
            try{
                const response = await axios.post(HOST + '/template',{},{
                    headers:{
                        "Authorization":this.context.token,
                    }
                });

                if(response.status === 200){
                    //console.log(response.data);
                    if(response.data.success === true){
                        //console.log('---------------------resumes----------------');
                        //console.log(response.data.data);
                        this.setState({templates:response.data.data});
                    }else{
                        alert('Someting went wrong! Please restart the app');
                    }
                }else{
                    alert('401');
                }
    
            }catch(error){
                //console.log(error);
                alert('Something went wrong');
            }
        }else{
            alert('no network');
        }

        this.setState({showLoading:false});
        
    }

    _onSubmit = ()=>{
        let resumeData = {...this.props.route.params.resumeData};
        resumeData.templateid = this.state.checkid;
        let templateData={
            templateData: resumeData
        }
        this.props.navigation.push('Preview',{
            templateData:templateData
        });
    }


    render() {
        let {checkid}  = this.state;
        //console.log('resuem data printing');
        //console.log(this.props.route.params.resumeData);
        if(this.state.showLoading)
            return <ActivityLoading msg="Loading Templates"/>
        else
        return (
            <>
            <ScrollView>
                <View style={styles.container}>

                {
                    this.state.templates.map((template,index)=>{
                
                    return  <View style={styles.imageContainer} key={index}>
                                <Pressable
                                    onPress={()=>this.setState({checkid:template.id})}
                                >
                                    <Image source={{uri:template.thumbnail}} style={styles.image} resizeMode="stretch"/>
                                </Pressable>
                                {checkid===template.id?
                                    <View style={styles.checkbox}>
                                        <MaterialCommunityIcons name="check-circle" size={40} color="#92B2FD"/>
                                    </View>
                                    :
                                    null
                                }
                            </View>
                    })
                }







                </View>
            </ScrollView>
            {checkid!=0?
                <View style={{marginTop:10,width:'100%',position:'absolute',bottom:0}}>
                    <LinearGradient
                        colors={['rgba(173,127,251,1)','rgba(146,178,253,1)']}
                        end={{x:0.9,y:0.9}}
                        >
                            <Button style={styles.nextButton} labelStyle={styles.nextButtonText} mode="text" color="#ffffff" onPress={this._onSubmit}>
                                Preview
                            </Button>
                    </LinearGradient>
                </View>
            :
                null
            }
            </>
        )
    }
}

const styles = StyleSheet.create({
    container:{
        flexDirection:'row',

        justifyContent:'flex-start',
        alignItems:'flex-end',
        flexWrap:'wrap',
        paddingBottom:70,
    },
    imageContainer:{
        position:'relative',
        width:'50%',
        height:200,
        padding:5,
        marginVertical:5,
    },
    image:{
        borderRadius: 5,
        width: '100%',
        height:200,
    },
    checkbox:{
        position:'absolute',
        zIndex:1,
        top: 0,
        left:0,
        bottom:0,
        right:0,
        justifyContent:'center',
        alignItems:'center',
        backgroundColor:'#0008',
        borderRadius:5,
        height:200,
        marginVertical:5,
        marginHorizontal:5,
    },
    nextButton:{
        paddingVertical: 10,
    },
    nextButtonText:{
        fontWeight:'bold',
        fontSize:20
    }
})


ChooseTemplate.contextType = ERContext;